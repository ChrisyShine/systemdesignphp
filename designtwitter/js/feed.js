class Feed extends React.Component {
	render() {
		return (
			<div>
	    		<div><span>{this.props.user}</span></div>
	    		<div>{this.props.time}</div>
	    		<div>{this.props.message}</div>
	    	</div>
		);
	}
}

class FeedList extends React.Component {
	constructor(props) {
	    super(props);
	    this.state = {
	    	feeds: [],
	    	isLoaded: false
	    };
	}

	componentDidMount() {
		
		fetch('feed_controller.php', {
				credentials: 'include',
	            method: "GET",  
	            headers: {  
	                "Content-Type": "application/json"  
	            }
			}).then((res) => {
		    	  return res.json();
		    }).then(
		        (result) => {
		        	console.log(result);
			        this.setState({
			            isLoaded: true,
			            feeds: result
			        });
		        },
		        (error) => {
		          this.setState({
		            isLoaded: true,
		            error
		          });
		        }
		      )
	}
 
	componentWillUnmount() {
	    this.serverRequest.abort();
	}

	updateFeeds(feed) {
		var feeds = this.state.feeds;
		feeds.unshift(feed);
		this.setState({
            isLoaded: true,
            feeds: feeds
        });
	}
	
	render() {
		var feeds = this.state.feeds;
		var feedItems = feeds.map((feed) =>
			<Feed key={feed.id} user={feed.user} time={feed.time} message={feed.message}/>
		);
		return (
			<div>
				{feedItems}
			</div>
		);
	}
}


class FeedContainer extends React.Component {
	
	constructor(props) {
	    super(props);
	    this.state = {
	    	isLoaded: false
	    };
	    this.handlePostAction = this.handlePostAction.bind(this);
	}
	
	handlePostAction(event) {
		var $messageArea = this.refs.messageArea;
		
		var payload = {"message": $messageArea.value};
		var data = new FormData();
		data.append( "json", JSON.stringify( payload ) );
		
		fetch('feed_controller.php', {
			credentials: 'include',
            method: "POST",  
            headers: {  
                "Content-Type": "application/json"  //x-www-form-urlencoded
            },
            body: JSON.stringify( payload )// 'message=' + $messageArea.value
		}).then((res) => {
	    	  return res.json();
	    }).then(
	        (result) => {
	        	console.log(result);
	        	var feedList = this.refs.feedList;
	        	feedList.updateFeeds(result);
	        	$messageArea.value = '';
	        },
	        (error) => {
	          
	        }
	      )
	}
	
	render() {
		var $feedListEle = <FeedList ref="feedList"/>;
		return (
			<div>
				<div>
					<textarea ref="messageArea" id="feedarea" name="message" rows="5" cols="40"></textarea>
					<button onClick={this.handlePostAction}>POST</button>
				</div>
				{$feedListEle}
			</div>
		);
	}
}






ReactDOM.render(
  <FeedContainer />,
  document.getElementById('feeds')
);

